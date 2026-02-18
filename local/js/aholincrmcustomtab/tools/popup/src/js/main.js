BX.namespace('Aholincrmcustomtab.Tools.Popup');

BX.Aholincrmcustomtab.Tools.Popup = {
    popup: {},
    popupCode: 'default',
    node: null,
    content: '',
    darkMode: false,
    autoHide: false,
    init: function (builder) {
        this.popupCode = builder.popupCode;
        this.node = builder.node;
        this.content = builder.content;
        this.darkMode = builder.darkMode;
        this.autoHide = builder.autoHide;

        return this;
    },
    createAndShow: function () {
        this.popup = BX.PopupWindowManager.create(
            this.popupCode,
            this.node,
            {
                content: this.content,
                darkMode: this.darkMode,
                autoHide: this.autoHide,
            }
        );

        this.popup.show();
    },
    show: function () {
        this.popup.show();
    },
    close: function () {
        this.popup.close();
    },
    destroy: function () {
        this.popup.destroy();
    }
};
