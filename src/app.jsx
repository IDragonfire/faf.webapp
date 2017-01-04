import React from 'react';
import ReactDOM from 'react-dom';

import {Router, Route, Link, hashHistory} from 'react-router';

import ClanPage from './ClanPage.jsx';
import './main.scss';

ReactDOM.render(
    <Router history={hashHistory }>
      <Route>
        <Route path="/clan/:clanid" component={ClanPage} />
      </Route>
    </Router>,
    document.getElementById('app')
);
