import JsonApi from 'devour-client'

let jsonApi = new JsonApi({
  //apiUrl: 'https://japi.test.faforever.com/data',
  apiUrl: 'http://localhost:5000/data',
  pluralize: false
});
jsonApi.headers['Accept'] = 'application/json';

jsonApi.define('clan', {
  description: '',
  name: '',
  tag: '',
  tagcolor: null,
  createTime: null,
  founder: {
    jsonApi: 'hasOne',
    type: 'player'
  },
  leader: {
    jsonApi: 'hasOne',
    type: 'player'
  },
  memberships: {
    jsonApi: 'hasMany',
    type: 'clan_membership'
  }
});

jsonApi.define('clan_membership', {
  createTime: null,
  updateTime: null,
  clan: {
    jsonApi: 'hasOne',
    type: 'clan'
  },
  player: {
    jsonApi: 'hasOne',
    type: 'player'
  }
});

jsonApi.define('player', {
  login: '',
  eMail: ''
});

const Api = jsonApi;

export {
  Api
}
