import React, { useState, useEffect } from "react";
import { Button, TextField, Table, TableBody, TableCell, TableContainer, TableHead, TableRow, Paper } from "@mui/material";
import './CRUD.css';


const CurrencyManagement = () => {
  const [combinations, setCombinations] = useState([]);
  const [baseCurrency, setBaseCurrency] = useState("");
  const [targetCurrency, setTargetCurrency] = useState("");
  const [rate, setRate] = useState("");

  useEffect(() => {
    // Fetch existing currency combinations from the API when the component mounts
    fetch("/api/exchange_rates")
      .then((response) => response.json())
      .then((data) => {
        setCombinations(data);
      })
      .catch((error) => console.error("Error fetching currency combinations:", error));
  }, []);

  const handleAddCombination = () => {
    // Validate input
    if (!baseCurrency || !targetCurrency || !rate) {
      alert("Please fill in all fields.");
      return;
    }
    console.log("Data to be sent:", { baseCurrency, targetCurrency, rate });
    // Send a POST request to add the new combination to the database
    fetch("/api/exchange_rates/add", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        baseCurrency,
        targetCurrency,
        rate: parseFloat(rate),
      }),
    })
      .then((response) => response.json())
      .then((data) => {
        // Update the list of combinations with the newly added combination
        setCombinations([...combinations, data]);
        // Reset the input fields
        setBaseCurrency("");
        setTargetCurrency("");
        setRate("");
      })
      .catch((error) => console.error("Error adding currency combination:", error));
  };
  const handleDeleteCombination = (id) => {
    // Send a DELETE request to remove the selected combination from the database
    fetch(`/api/exchange_rates/${id}`, {
      method: "DELETE",
    })
      .then((response) => response.json())
      .then(() => {
        // Update the list of combinations by removing the deleted combination
        setCombinations(combinations.filter((combination) => combination.id !== id));
      })
      .catch((error) => console.error("Error deleting currency combination:", error));
  };
  const handleEditCombination = (combination) => {
    setSelectedCombination(combination);
    setEditDialogOpen(true);
  };
  console.log(combinations)

  return (
    <div>
    <div className="table-container">
      <TableContainer component={Paper}>
        <Table>
          <TableHead>
            <TableRow>
              <TableCell>From Currency</TableCell>
              <TableCell>To Currency</TableCell>
              <TableCell>Rate</TableCell>
              <TableCell>Actions</TableCell>
            </TableRow>
          </TableHead>
          <TableBody>
            {combinations.map((combination) => (
              <TableRow key={combination.id}>
                <TableCell>{combination.base_currency}</TableCell>
                <TableCell>{combination.target_currency}</TableCell>
                <TableCell>{combination.rate}</TableCell>
                <TableCell>
                  {/* Edit and Delete buttons for each combination */}
                  <Button variant="contained" color="primary" onClick={() => handleEditCombination(combination.id)}>
                    Edit
                  </Button>
                  <Button variant="contained" color="secondary" onClick={() => handleDeleteCombination(combination.id)}>
                    Delete
                  </Button>
                </TableCell>
              </TableRow>
            ))}
          </TableBody>
        </Table>
      </TableContainer>
      {/* Form to add a new currency combination */}
      
    </div>
    <div className="add-currency-big-container">
      <div className="add-currency-small-container">
        <h2>Add New Currency Combination</h2>
        <TextField label="From Currency" value={baseCurrency} onChange={(e) => setBaseCurrency(e.target.value)} />
        <TextField label="To Currency" value={targetCurrency} onChange={(e) => setTargetCurrency(e.target.value)} />
        <TextField label="Rate" value={rate} onChange={(e) => setRate(e.target.value)} />
        </div>
        <Button variant="contained" color="primary" onClick={handleAddCombination}>
          Add
        </Button>
      </div>
    </div>
  );
};


export default CurrencyManagement;