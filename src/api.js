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
  tag : '',
  tagcolor: null,
  createTime: null,
  founder : { 
    jsonApi: 'hasOne',
    type: 'player'
  },
  leader: {
    jsonApi: 'hasOne',
    type: 'player'
  },
  members: {
    jsonApi: 'hasMany',
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
