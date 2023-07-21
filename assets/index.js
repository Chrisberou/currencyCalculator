import React, { Component } from "react";
import ReactDom from "react-dom/client";
import Header from "./components/Header/Header";
import "./styles/app.css";
import Footer from "./components/Footer/Footer";
//import LoginForm from "./components/LoginForm/LogInForm";
import LoginFormTest from "./components/LoginForm/LogInFromTest";
import CurrencyCalculator from "./components/CurrencyCalculator/CurrencyCalculator";
import { Provider } from "react-redux";

class LoginApp extends Component {
  render() {
    return (
      <div className="body">
        <Provider store ={store}>
        <Header />
       <CurrencyCalculator/>
        <Footer />
        </Provider>
      </div>
    );
  }
}
if (document.getElementById('login')) {
    console.log('asdsad')
}

ReactDom.createRoot(document.getElementById("root")).render(<LoginApp />);
//ReactDOM.render(<App />, document.getElementById("root"));
