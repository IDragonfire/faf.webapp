import React from 'react';

export default class NavBar extends React.Component {
  render() {
    return (
      <nav className="navbar navbar-default navbar-fixed-top">
      <div className="container">
        <div className="navbar-header">
          <button type="button" className="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          <span className="sr-only">Toggle navigation</span>
          <span className="icon-bar"></span>
          <span className="icon-bar"></span>
          <span className="icon-bar"></span>
          </button>
          <a className="navbar-brand" href="#">
            <img alt="FaF" src="/images/faf_32x32.png"/>
          </a>
        </div>
        <div id="navbar" className="navbar-collapse collapse">
          <ul className="nav navbar-nav">
            <li className="active"><a href="{{ url_for('index') }}">Home</a></li>
            <li className="active"><a href="{{ url_for('clans') }}">Clans</a></li>
            <li className="active"><a href="{{ url_for('members') }}">Members</a></li>
          </ul>
          <ul className="nav navbar-nav navbar-right">
            <li><a href="#">My Clan</a></li>
            <li><p className="navbar-text">Logged in as: MyName</p></li>
          </ul>
        </div>
      </div>
    </nav>
    );
  }
}
