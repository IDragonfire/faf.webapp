import React from 'react';

export default class InputPair extends React.Component {

    render() {
        return (
            <div className="input-group input-group-sm">
                <span className="input-group-addon" id={this.props.label}>{this.props.label}</span>
                <input disabled type="text" className="form-control" placeholder={this.props.value} aria-describedby={this.props.label} />
            </div>
        );
    }
}
