import { Ability } from '@casl/ability';
let rules = [];
if(window.user) {
    let user = window.user;
    if (user.roles[0].name === 'Admin')
        rules = [{subject: 'all', action: 'manage'}];
    else
        rules = [{subject: 'all', actions: user.roles.map((rule) => rule.permissons).join()}];

}

export default new Ability(rules);
