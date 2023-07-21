import React, { Component } from "react";
import ReactDom from "react-dom/client";
import CurrencyManagement from "./CRUDComponent";
import Header from '../assets/components/Header/Header.jsx';
import Footer from '../assets/components/Footer/Footer.jsx';

class CRUDPage extends Component {
  render() {
    return (
      <div className="body">
        <Header/>
        <CurrencyManagement />
        <Footer/>
      </div>
    );
  }
}

ReactDom.createRoot(document.getElementById("crud")).render(
  <CRUDPage />
);
