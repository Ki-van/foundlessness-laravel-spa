export class Article {
    constructor(domain, tags) {
        this.domain = domain;
        this.tags = tags;
    }
    latest_public_version = {
        heading: '',
        description: '',
        body: ''
    }
}

