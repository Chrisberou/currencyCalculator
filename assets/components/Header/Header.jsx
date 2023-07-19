import React from 'react';
import './Header.css'; // Import the CSS file for styling
import logo from './Calculator-icon.png'

const Header = () => {
  return (
    <header className="header">
      <div className="logo">
        <img src={logo} alt="Calculator Logo" />
      </div>
      <div className="credentials">
        <p>Your Credentials</p>
      </div>
    </header>
  );
};

export default Header;