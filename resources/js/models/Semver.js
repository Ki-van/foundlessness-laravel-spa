export class Semver{
    constructor(semver = null){
        if(semver) {
            let parsed = semver.split('.').map(value => Number.parseInt(value));
            this.major = parsed[0];
            this.minor = parsed[1];
            this.patch = parsed[2];
        } else
        {
            this.major = 1;
            this.minor = 0;
            this.patch = 0;
        }
    }

    incrementMajor() {
        this.major++;
        this.minor = 0;
        this.patch = 0;
    }

    incrementMinor() {
        this.minor++;
        this.patch = 0;
    }
    incrementPatch() {
        this.patch++;
    }

    toString(){
        return [this.major, this.minor, this.patch].join('.');
    }
}
