export class Article {
    constructor(domain, tags) {
        this.domain = domain;
        this.tags = tags;
    }
    latest_version = {
        heading: '',
        description: '',
        body: ''
    }

    latest_public_version = {
        heading: '',
        description: '',
        body: ''
    }
}

