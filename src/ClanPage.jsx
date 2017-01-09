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
    Api.one('clan', this.props.params.clanid).get({ include: 'members,founder,leader' })
      .then(this.setData.bind(this)).catch(error => console.error(error));
  }

  setData(data) {
    if (data == null) {
      console.log('No clan found');
    }
    this.setState({ clan: data });
  }

  renderClan() {

    return <div>
      {this.renderClanData()}
      {this.renderClanMembers()}
    </div>
  }

  renderClanData() {
    let d = new Date(this.state.clan.createTime);
    return <div className="well bs-component">
      <InputPair disabled={true} label="Tag" value={this.state.clan.tag} />
      <InputPair disabled={true} label="Leader" value={this.state.clan.leader.login} />
      <InputPair disabled={true} label="Founder" value={this.state.clan.founder.login} />
      <InputPair disabled={true} label="Created At:" value={d.toISOString().slice(0, 10)} />
      <textarea disabled className="form-control">{this.state.clan.description}</textarea>
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

  render() {
    if (this.state.clan) {
      return <Page title={"Clan: " + this.state.clan.name}>{this.renderClan()}</Page>
    }
    return <Page title="Loading..." />;
  }
}
