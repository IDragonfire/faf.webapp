import React from 'react';
import ReactDOM from 'react-dom';
import { Api } from './api.js';

import Page from './Page.jsx';
import InputPair from './InputPair.jsx';

export default class CreateClan extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            clanTag: '',
            clanName: '',
            clanDesc: ''
        }
    }

    onTagChange(event) {
        let newValue = event.target.value
        if (newValue.length <= 3) {
            this.setState({ clanTag: newValue });
        }
    }

    onNameChange(event) {
        let newValue = event.target.value
        if (newValue.length <= 40) {
            this.setState({ clanName: event.target.value });
        }
    }

    onDescChange(event) {
        this.setState({ clanDesc: event.target.value })
    }

    renderClanData() {
        let d = new Date();
        return <div className="well bs-component">
            <InputPair label="Tag" value={this.state.clanTag} onChange={this.onTagChange.bind(this)} />
            <InputPair label="Name" value={this.state.clanName} onChange={this.onNameChange.bind(this)} />
            <InputPair disabled={true} label="Leader" value="You" />
            <InputPair disabled={true} label="Founder" value="You" />
            <InputPair disabled={true} label="Created At:" value={d.toISOString().slice(0, 10)} />
            <textarea className="form-control" value={this.state.clanDesc} onChange={this.onDescChange.bind(this)} />
            <button onClick={this.submitData.bind(this)} className="btn btn-default btn-lg">Create Wew Clan</button>
        </div>
    }

    submitData() {
        console.log(this.state);
    }

    render() {
        return (
            <Page title="Create New Clan">{this.renderClanData()}</Page>
        );
    }
}
