import React from "react";
import DropdownButton from "../DropDown/dropDown";
import TextField from "../TextField/TextField";
import './CurrencyCalculator.css';

const CurrencyCalculator =()=>{
    return(
        <div className="big-container">
            <h1 className="header-container">Convert Currencies</h1>
            <div className="small-container">
                <p className="p-properties">From</p>
                <DropdownButton/>
                <TextField name="From"/>
                <p className="p-properties">To</p>
                <TextField name="To"/>
                <DropdownButton/>
                
            </div>
        </div>
    );

};

export default CurrencyCalculator;