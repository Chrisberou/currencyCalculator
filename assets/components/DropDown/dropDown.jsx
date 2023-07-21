import React, { useState, useEffect } from 'react';
import './dropDown.css'; // Import the CSS file for styling

const DropdownButton = ({onSelectCurrency }) => {
  const [isOpen, setIsOpen] = useState(false);
  const [selectedOption, setSelectedOption] = useState(null);
  const [currencies, setCurrencies] = useState([]);

  useEffect(() => {
    // Fetch the currencies from the API when the component mounts
    fetch('/api/currencies')  
      .then(response => response.json())
      .then(data => {
        setCurrencies(data); // Set the fetched currencies in the state
      })
      .catch(error => console.error('Error fetching currencies:', error));
  }, []);

  const toggleDropdown = () => {
    setIsOpen(!isOpen);
  };

  const handleOptionClick = (option) => {
    setSelectedOption(option);
    setIsOpen(false);
    onSelectCurrency(option);
  };

  return (
    <div className="dropdown-container">
      <button className="dropdown-button" onClick={toggleDropdown} >
        {selectedOption || 'Select'}
      </button>
      {isOpen && (
        <ul className="dropdown-menu">
          {currencies.map((currency) => (
            <li key={currency.code} onClick={() => handleOptionClick(currency.name)}>
              {currency.name}
            </li>
          ))}
        </ul>
      )}
    </div>
  );
};

export default DropdownButton;
