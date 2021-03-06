class InitiateTool {
    constructor({data, api,config, readOnly, block}){
        this.readOnly = readOnly;
        api.blocks.insert('header', { level: 1, text: "Главный заголовок"}, {placeholder: "Enter main heading"});
        api.blocks.insert('paragraph', {text: "Бредни сюда..."}, {},);
    }

    /**
     * Returns true to notify core that read-only is supported
     *
     * @returns {boolean}
     */
    static get isReadOnlySupported() {
        return true;
    }
}

module.exports = InitiateTool;
