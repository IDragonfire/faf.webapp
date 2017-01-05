import React from 'react';

import NavBar from './NavBar.jsx';
import Footer from './Footer.jsx'

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
    }
    render() {
        return (
            <div>
                <NavBar />
                <div className="container">
                    <h1 id="title">Home</h1>
                    <div className="jumbotron" id="header">
                        <center>
                            <div className="panel-transparent">
                                <h1>Clan Management</h1>
                                <h2>Forged Alliance Forever</h2>
                            </div>
                            <div className="row" style={{ "marginTop": "15px" }}>
                                <a href="#" className="btn btn-default btn-lg">
                                    <i className="fa fa-plus-circle"></i> Create Clan
                                </a>
                                <a href="#" type="button" className="btn btn-default btn-lg">
                                    <i className="fa fa-users"></i> Invite Players
                                </a>
                                <a href="http://www.faforever.com" className="btn btn-default btn-lg">
                                    <i className="fa fa-gamepad"></i> Play Together
                                </a>
                            </div>
                        </center>
                    </div>
                </div>
                <Footer />
            </div>
        );
    }
}
