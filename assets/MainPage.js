import React, { Component } from "react";
import ReactDom from "react-dom/client";
import Header from "./components/Header/Header";
import "./styles/MainPage.css";
import Footer from "./components/Footer/Footer";
//import LoginForm from "./components/LoginForm/LogInForm";
import CurrencyCalculator from "./components/CurrencyCalculator/CurrencyCalculator";


class MainPage extends Component {
  render() {
    return (
      <div className="body">
        <Header />
       <CurrencyCalculator/>
        <Footer />
      </div>
    );
  }
}


ReactDom.createRoot(document.getElementById("main")).render(<MainPage />);
