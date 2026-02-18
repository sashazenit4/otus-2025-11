BX(() => {
    if (!BX.Currency) {
        return;
    }

    if (!BX.Currency.Editor) {
        return;
    }

    if (typeof BX.Currency?.Editor?.getUnFormattedValue_old === "undefined") {
        BX.Currency.Editor.getUnFormattedValue_old = BX.Currency.Editor.getUnFormattedValue;

        BX.Currency.Editor.getUnFormattedValue = function (value, currency) {
            let prefix = '';

            if (value.length > 0) {
                if (value.substring(0, 1) === '-') {
                    prefix = '-';
                    value = value.substring(1);
                }
            }

            let unFormattedValue = BX.Currency.Editor.getUnFormattedValue_old(value, currency);

            return prefix + unFormattedValue;
        }
    }

    if (typeof BX.Currency?.Editor?.oldGetFormattedValue === "undefined") {
        BX.Currency.MoneyEditor.oldGetFormattedValue = BX.Currency.MoneyEditor.getFormattedValue;
        BX.Currency.MoneyEditor.getFormattedValue = function (baseValue, currency) {
            let prefix = '';

            if (baseValue.length > 0) {
                if (baseValue.substring(0, 1) === '-') {
                    prefix = '-';
                    baseValue = baseValue.substring(1);
                }
            }

            let result = BX.Currency.MoneyEditor.oldGetFormattedValue(baseValue, currency);
            return prefix + result;
        }
    }
})

