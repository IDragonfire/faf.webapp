import React from 'react';
import ReactDOM from 'react-dom';

import {Router, Route, Link, hashHistory} from 'react-router';

import Home from './Home.jsx';

ReactDOM.render(
    <Router history={hashHistory }>
      <Route>
        <Route path="/" component={Home} />
      </Route>
    </Router>,
    document.getElementById('app')
);
