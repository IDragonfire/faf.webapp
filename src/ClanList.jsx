import React from 'react';
import ReactDOM from 'react-dom';
import { Api } from './api.js';
import ReactTable from 'react-table';

import Page from './Page.jsx';

export default class ClanList extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      list: null
    }
  }

  componentDidMount() {
   Api.all('clan').get({include: 'clanFounder,clanLeader'})
   .then(this.setData.bind(this));
  }

  setData(data) {
    if(data == null) {
      console.log('Api not available');
    }
    console.log(data);
    this.setState({list: data});
  }

  renderLoading() {
    return 'Loading ...';
  }

  renderData() {
    const columns = [{
        header: 'Id',
        accessor: 'id' 
      },{
        header: 'Tag',
        accessor: 'clanTag' 
      },{
        header: 'Name',
        accessor: 'clanName' 
      },{
        header: 'Clan Leader',
        accessor: 'clanLeader.login' 
      }]
    return <ReactTable data={this.state.list} columns={columns} />
  }

  render2() {
    if(this.state.list) {
      return this.renderData();
    } 
    return  this.renderLoading();
  }
  
  render() {
    return (
      <Page title="Clans">{this.render2()}</Page>
    );
  }
}
