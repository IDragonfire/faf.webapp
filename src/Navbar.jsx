import React from 'react';
import { Link } from 'react-router'


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
            <li><Link to="/" activeClassName="active">Home</Link></li>
            <li><Link to="/clans" activeClassName="active">Clans</Link></li>
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
