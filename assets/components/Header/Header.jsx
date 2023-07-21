import React from 'react';
import './Header.css'; // Import the CSS file for styling
import logo from './Calculator-icon.png'

const Header = () => {
  return (
    <header className="header">
      <div className="logo">
        <a href="http://127.0.0.1:8000/main"><img src={logo} alt="Calculator Logo" href='/main'/></a>
      </div>
    </header>
  );
};

export default Header;