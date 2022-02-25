export default class InitiateTool {
    constructor({data, api}){
        api.blocks.insert('header', { level: 1, text: "Главный заголовок"}, {placeholder: "Enter main heading"});
        api.blocks.insert('paragraph', {text: "Бредни сюда..."}, {},);
    }
}
