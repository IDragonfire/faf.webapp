import React from 'react';
import ReactDOM from 'react-dom';
import { Api } from './api.js';
import ReactTable from 'react-table'

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

  setData(data) {
    if(data == null) {
      console.log('No clan found');
    }
    console.log(data);
    this.setState({clan: data});
  }

  renderLoading() {
    return 'Loading ...';
  }

  renderClan() {
    let d = new Date(this.state.clan.createDate);
    const columns = [{
        header: 'Id',
        accessor: 'id' 
      },{
        header: 'Member Since',
        accessor: 'joinClanDate' 
      },{
        header: 'Player',
        accessor: 'player.login'
      }]
    return <div>
             <h2>{this.state.clan.clanName}</h2>
             <div>{this.state.clan.clanDesc}</div>
             <div>Clan Leader: {this.state.clan.clanLeader.login}</div> 
             <div>Clan Founder: {this.state.clan.clanFounder.login}</div> 
             <div>Create Date: {d.toISOString().slice(0,10)}</div>
             <ReactTable data={this.state.clan.memberships} columns={columns} />
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
