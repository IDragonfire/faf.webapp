import React from 'react';
import reqwest from 'reqwest';

export default class Home extends React.Component {
  constructor() {
    super();
    reqwest({
        url: "https://japi.test.faforever.com/data/clan?include=memberships,clanFounder",
        method: 'GET',
        type: 'json',
        success: this.getData
    });
  }

  getData(data) {
    console.log(data.data[0]);
    console.log(data.included);
  }
  
  render() {
    return (
      <div id="main">
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
                <img alt="FaF" src="/images/faf_32x32.png" />
              </a>
            </div>
            <div id="navbar" className="navbar-collapse collapse">
              <ul className="nav navbar-nav">
                <li className="active"><a href="">Home</a></li>
                <li className="active"><a href="">Clans</a></li>
                <li className="active"><a href="">Members</a></li>
              </ul>
              <ul className="nav navbar-nav navbar-right">
                <li><a href="#">My Clan</a></li>
                <li><p className="navbar-text">Logged in as: MyName</p></li>
              </ul>
            </div>
          </div>
        </nav>
        <div className="container">
          <h1 id="title">Home</h1>
        </div>
        <footer className="footer">
          <div className="container secondary">
            <ul className="nav navbar-nav">
              <li><a href="http://www.faforever.com/">Forged Alliance Forever</a></li>
              <li><a href="http://forums.faforever.com/">Forum</a></li>
              <li><a href="https://github.com/FAForever/clans">Sources</a></li>
              <li><a href="https://github.com/FAForever/clans/issues">Issues</a></li>
              <li><a href="https://github.com/FAForever/clans/network/members">Authors</a></li>
            </ul>
          </div>
        </footer>
      </div>
    );
  }
}
