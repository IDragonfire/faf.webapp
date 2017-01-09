import React from 'react';
import { Link,hashHistory } from 'react-router';

import Page from './Page.jsx';
import { Api } from './api.js';

export default class Home extends React.Component {
    componentDidMount() {
        $(document).ready(function () {
            $('#header').bgswitcher({
                images: ['/images/spider.jpg', '/images/zar.jpg', '/images/bombers.jpg', '/images/explosion.jpg', '/images/sera.jpg'],
                interval: 5000 + 5000,
                shuffle: true,
                duration: 5000 // Effect duration
            })
        });
        if(this.props.params.token) {
            localStorage.setItem("token", this.props.params.token);
            Api.headers['Authorization'] = `Bearer ${localStorage.getItem("token")}`
            hashHistory.push("");
        }
       Api.headers['Authorization'] = `Bearer ${localStorage.getItem("token")}`
       Api.one('player', 1).get().then(function(data) {
           console.log(data);
       }).catch(error => console.error(error));
    }
    render() {
        return (
            <Page title="Home">
                    <div className="jumbotron" id="header">
                        <center>
                            <div className="panel-transparent">
                                <h1>Clan Management</h1>
                                <h2>Forged Alliance Forever</h2>
                            </div>
                            <div className="row" style={{ "marginTop": "15px" }}>
                                <Link to="/action/create_clan" className="btn btn-default btn-lg">
                                    <i className="fa fa-plus-circle"></i> Create Clan
                                </Link>
                                <a href="#" type="button" className="btn btn-default btn-lg">
                                    <i className="fa fa-users"></i> Invite Players
                                </a>
                                <a href="http://www.faforever.com" className="btn btn-default btn-lg">
                                    <i className="fa fa-gamepad"></i> Play Together
                                </a>
                            </div>
                        </center>
                    </div>
            </Page>
        );
    }
}
