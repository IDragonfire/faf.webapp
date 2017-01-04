import React from 'react';
import { Api } from './api.js'

export default class ClanPage extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      clan: null
    }
       
  }

  componentDidMount() {
   Api.one('clan', 21).get({include: 'memberships,memberships.player,clanFounder,clanLeader'}).then(this.setData.bind(this));
  }

  setData(data) {
    this.setState({clan: data});
  }

  renderLoading() {
    console.log('test');
    return 'Loading ...';
  }
  renderClan() {
    console.log(this.state);
    return<div> Clan Details
            <h2>{this.state.clan.clanName}</h2>
            <div>{this.state.clan.clanDesc}</div>
            <div>Clan Leader: {this.state.clan.clanLeader.login}</div> 
            <div>Clan Founder: {this.state.clan.clanFounder.login}</div> 
          </div>
  }

  render2() {
     console.log('render2');
    if(this.state.clan) {
      return this.renderClan();
    } return  this.renderLoading();
  }
  
  render() {
  
    return (
      <div id="main">{this.render2()}</div>
    );
  }
}
