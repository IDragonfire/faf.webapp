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
   Api.one('clan', this.props.params.clanid).get({include: 'memberships,memberships.player,clanFounder,clanLeader'})
   .then(this.setData.bind(this));
  }

  exf(d) {
    console.log(d);
  }

  setData(data) {
    if(data == null) {
      console.log('No clan found');
    }
    this.setState({clan: data});
  }

  renderLoading() {
    return 'Loading ...';
  }

  renderClan() {
    let d = new Date(this.state.clan.createDate);
  
    return <div>
             <h2>{this.state.clan.clanName}</h2>
             <div>{this.state.clan.clanDesc}</div>
             <div>Clan Leader: {this.state.clan.clanLeader.login}</div> 
             <div>Clan Founder: {this.state.clan.clanFounder.login}</div> 
             <div>Create Date: {d.toISOString().slice(0,10)}</div>
          </div>
  }

  render2() {
    if(this.state.clan) {
      return this.renderClan();
    } 
    return  this.renderLoading();
  }
  
  render() {
    return (
      <div id="main">{this.render2()}</div>
    );
  }
}
