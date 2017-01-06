import JsonApi from 'devour-client'

let jsonApi = new JsonApi({
  apiUrl: 'https://japi.test.faforever.com/data',
  pluralize: false
});
jsonApi.headers['Accept'] = 'application/json';

jsonApi.define('clan', {
  clanDesc: '',
  clanName: '',
  clanTag : '',
  clanTagColor: null,
  createDate: null,
  status: -1,
  clanFounder : { 
    jsonApi: 'hasOne',
    type: 'player'
  },
  clanLeader: {
    jsonApi: 'hasOne',
    type: 'player'
  },
  memberships: {
    jsonApi: 'hasMany',
    type: 'clan_membership'
  }
});

jsonApi.define('player', {
  login: '',
  eMail: ''
});

jsonApi.define('clan_membership', {
  joinClanDate: '',
  clan: {
    jsonApi: 'hasOne',
    type: 'clan'
  },
  player: {
    jsonApi: 'hasOne',
    type: 'player'
  }
});

const Api = jsonApi;

export {
    Api
}
