import React, { Component } from "react";
import  ReactDom  from "react/client";
import Header from "./components/Header/Header";
import "./styles/app.css";
import Footer from "./components/Footer/Footer";
//import LoginForm from "./components/LoginForm/LogInForm";
import CurrencyCalculator from "./components/CurrencyCalculator/CurrencyCalculator";
import  ReactDOM  from "react-dom";

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


//ReactDom.createRoot(document.getElementById("main")).render(<MainPage />);
if(document.getElementById("main"))
{
  ReactDOM.render(<MainPage/>)
}