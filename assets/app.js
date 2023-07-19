import React, { Component } from "react";
import ReactDom from "react-dom/client";
import CurrencyCalculator from "./components/CurrencyCalculator/CurrencyCalculator";
import Header from "./components/Header/Header";


class App extends Component {
    
  render() {
    
    return (
   <div>
    <Header/>
     <CurrencyCalculator/>

     </div>
    );
  }
} 

ReactDom.createRoot(document.getElementById("root")).render(<App />);