<?php

namespace Aholin\Crmcustomtab\Controllers;

use Otus\Orm\BookTable;
use Otus\Orm\AuthorTable;
use Bitrix\Main\Error;
use Bitrix\Main\Engine\Controller;
use Bitrix\Main\Type\DateTime;

class Book extends Controller
{
    public function configureActions(): array
    {
        return [
            'deleteElement' => [
                'prefilters' => [],
            ],
            'addBook' => [
                'prefilters' => [],
                'postfilters' => [],
            ],
            'createTestElement' => [
                'prefilters' => [],
                'postfilters' => [],
            ],
        ];
    }

    public function addBookAction(): array
    {
        try {
            $bookTitle = $this->request->get('bookTitle');
            $file = $this->request->getFile('bookFile');
            \CFile::SaveFile($file, 'uploaded_books');

            if (empty($bookTitle)) {
                $this->errorCollection->add([new Error('Не передано название')]);
                return [];
            }

            $addResult = BookTable::add([
                'TITLE' => $bookTitle,
            ]);

            if ($addResult->isSuccess()) {
                $result['BOOK_ID'] = $addResult->getId();
            } else {
                $this->errorCollection->add($addResult->getErrorMessages());
                return [];
            }
        } catch (\Exception $e) {
            $this->errorCollection->add([new Error($e->getMessage())]);
            return [];
        }

        return $result;
    }

    public function deleteElementAction(int $bookId): array
    {
        $result = [];

        try {
            $deleteResult = BookTable::delete($bookId);

            if ($deleteResult->isSuccess()) {
                return $result;
            } else {
                $this->errorCollection->add($deleteResult->getErrorMessages());
                return [];
            }
        } catch (\Exception $e) {
            $this->errorCollection->add([new Error($e->getMessage())]);
            return [];
        }
    }

    public function createTestElementAction(array $bookData): array
    {
        $newBookData = [
            'TITLE' => $bookData['bookTitle'] ?? '',
            'YEAR' => $bookData['publishYear'] ?? 2000,
            'PAGES' => $bookData['pageCount'] ?? 0,
            'PUBLISH_DATE' => DateTime::createFromText($bookData['publishDate'] ?? ''),
        ];

        $addResult = BookTable::add($newBookData);
        if (!$addResult->isSuccess()) {
            $this->errorCollection->add([new Error('Не удалось создать книгу')]);
            return [];
        }

        $bookId = $addResult->getId();
        $book = BookTable::getByPrimary($bookId)->fetchObject();

        $authorIds = $bookData['authors'];
        foreach ($authorIds as $authorId) {
            $author = AuthorTable::getByPrimary($authorId)->fetchObject();
            if ($author) {
                $book->addToAuthors($author);
            }
        }

        $updateResult = $book->save();

        if (!$updateResult->isSuccess()) {
            $this->errorCollection->add([new Error('Не удалось добавить авторов')]);
            return [];
        }

        return [
            'BOOK_ID' => $bookId
        ];
    }
}
