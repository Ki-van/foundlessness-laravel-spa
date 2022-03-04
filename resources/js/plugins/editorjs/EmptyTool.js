class EmptyTool {
    constructor({data, api,config, readOnly, block}){
        this.readOnly = readOnly;
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

module.exports = EmptyTool;
