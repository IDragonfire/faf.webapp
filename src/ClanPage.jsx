import React from 'react';
import ReactDOM from 'react-dom';
import { Api } from './api.js';

import Page from './Page.jsx';
import InputPair from './InputPair.jsx';

export default class ClanPage extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      clan: null
    }
  }

  componentDidMount() {
    Api.one('clan', this.props.params.clanid).get({ include: 'memberships,memberships.player,clanFounder,clanLeader' })
      .then(this.setData.bind(this));
  }

  setData(data) {
    if (data == null) {
      console.log('No clan found');
    }
    console.log(data);
    this.setState({ clan: data });
  }

  renderClan() {

    return <div>
      {this.renderClanData()}
      {this.renderClanMembers()}
    </div>
  }

  renderClanData() {
    let d = new Date(this.state.clan.createDate);
    return <div className="well bs-component">
      <InputPair label="Tag" value={this.state.clan.clanTag} />
      <InputPair label="Leader" value={this.state.clan.clanLeader.login} />
      <InputPair label="Founder" value={this.state.clan.clanFounder.login} />
      <InputPair label="Created At:" value={d.toISOString().slice(0, 10)} />
      <textarea disabled className="form-control">{this.state.clan.clanDesc}</textarea>
    </div>
  }

  renderClanMembers() {
    const columns = [{
      header: 'Id',
      accessor: 'id'
    }, {
      header: 'Member Since',
      accessor: 'joinClanDate'
    }, {
      header: 'Player',
      accessor: 'player.login'
    }]
    return <div className="well">
      <h2>Clan Members</h2>
      <table id="clan_members" className="table table-striped table-bordered" cellSpacing="0" width="100%">
        <thead>
          <tr>
            <th>Name</th>
            <th>Joined</th>
            <th>Actions</th>
          </tr>
        </thead>
      </table>
    </div>
  }

  render2() {
    if (this.state.clan) {
      return this.renderClan();
    }
  }

  getClanName() {
    if (this.state.clan) {
      return "Clan: " + this.state.clan.clanName;
    }
    return 'Loading ...';
  }

  render() {
    return (
      <Page title={this.getClanName()}>{this.render2()}</Page>
    );
  }
}
