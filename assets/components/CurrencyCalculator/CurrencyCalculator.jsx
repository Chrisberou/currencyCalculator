import React, { useState,useEffect } from "react";
import DropdownButton from "../DropDown/dropDown";
import TextField from "../TextField/TextField";
import "./CurrencyCalculator.css";
import { Button } from "@mui/material";
import axios from "axios"; // Import Axios library

const CurrencyCalculator = ({ user }) => {
  const [fromCurrency, setFromCurrency] = useState(null);
  const [toCurrency, setToCurrency] = useState(null);
  const [amount, setAmount] = useState("");
  const [convertedAmount, setConvertedAmount] = useState("");
  const [isAdmin, setIsAdmin] = useState(false)

  useEffect(() => {
    // Fetch the 'isAdmin' value from the server
    axios.get('/api/get_is_admin')
      .then((response) => {
        setIsAdmin(response.data.isAdmin);
      })
      .catch((error) => console.error('Error fetching isAdmin value:', error));
  }, []);
  console.log('isAdmin:', isAdmin);
  const handleConvert = () => {
    // Make sure fromCurrency and toCurrency are selected

    if (fromCurrency && toCurrency) {
      // Fetch the conversion rate from the API and calculate the converted amount
      fetch(`/api/convert`, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          baseCurrency: fromCurrency,
          targetCurrency: toCurrency,
          amount: parseFloat(amount),
        }),
      })
        .then((response) => response.json())
        .then((data) => {
          // Update the convertedAmount state with the result
          setConvertedAmount(data.convertedAmount);
        })
        .catch((error) => console.error("Error converting currencies:", error));
    }
  };
  const handleFromCurrencyChange = (selectedCurrency) => {
    console.log("hi");
    setFromCurrency(selectedCurrency);
    console.log("Selected From Currency:", selectedCurrency);
  };
  const handleToCurrencyChange = (selectedCurrency) => {
    setToCurrency(selectedCurrency);
    console.log("Selected to Currency:", selectedCurrency);
  };
  const handleSelectedAmountChange = (selectedAmount) => {
    setAmount(selectedAmount);
    console.log("Selected Amount " + selectedAmount);
  };

  return (
    <div className="big-container">
      <h1 className="header-container">Convert Currencies</h1>
      <div className="small-container">
        <p className="p-properties">From</p>
        <DropdownButton onSelectCurrency={handleFromCurrencyChange} />
        <TextField
          name="From"
          value={amount}
          placeholder={'Input'}
          selectedAmount={handleSelectedAmountChange}
        />
        <p className="p-properties">To</p>
        <DropdownButton onSelectCurrency={handleToCurrencyChange} />
        <TextField name="To" value={convertedAmount} placeholder={'Output'} readOnly />
      </div>
      <Button
        type="submit"
        variant="contained"
        color="grey"
        className="form-button"
        onClick={handleConvert}
      >
        Convert
      </Button>
      {/* Conditionally render the "EDIT DATABASE" button based on the user's admin status */}
      {isAdmin && ( // Conditionally render the "EDIT DATABASE" button if isAdmin is true
        <a href="http://127.0.0.1:8000/crud">
          <Button
            type="submit"
            variant="contained"
            color="grey"
            className="form-button"
          >
            EDIT DATABASE
          </Button>
        </a>
      )}
    </div>
  );
};

export default CurrencyCalculator;
