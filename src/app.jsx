import React from 'react';
import ReactDOM from 'react-dom';

import {Router, Route, Link, hashHistory} from 'react-router';

import Home from './Home.jsx';
import ClanPage from './ClanPage.jsx';
import './table.scss';
import './main.scss';


ReactDOM.render(
    <Router history={hashHistory }>
      <Route>
        <Route path="/" component={Home} />
        <Route path="/clan/:clanid" component={ClanPage} />
      </Route>
    </Router>,
    document.getElementById('app')
);
