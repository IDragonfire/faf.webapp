import React from 'react';

import NavBar from './NavBar.jsx';
import Footer from './Footer.jsx';

export default class Page extends React.Component {
    render() {
        return (
            <div>
                <NavBar />
                <div className="container">
                    <h1 id="title">{this.props.title}</h1>
                    {this.props.children}
                </div>
                <Footer />
            </div>
        );
    }
}
