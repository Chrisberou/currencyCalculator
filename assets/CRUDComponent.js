import React, { useState, useEffect } from "react";
import {
  Button,
  TextField,
  Table,
  TableBody,
  TableCell,
  TableContainer,
  TableHead,
  TableRow,
  Paper,
  Dialog,
  DialogTitle,
  DialogContent,
  DialogActions,
} from "@mui/material";
import "./CRUD.css";

const CurrencyManagement = () => {
  const [combinations, setCombinations] = useState([]);
  const [baseCurrency, setBaseCurrency] = useState("");
  const [targetCurrency, setTargetCurrency] = useState("");
  const [rate, setRate] = useState("");
  const [selectedCombination, setSelectedCombination] = useState(null);
  const [editDialogOpen, setEditDialogOpen] = useState(false);
  const [currencyCode, setCurrencyCode] = useState("");
  const [currencyName, setCurrencyName] = useState("");

  useEffect(() => {
    // Fetch existing currency combinations from the API when the component mounts
    fetch("/api/exchange_rates")
      .then((response) => response.json())
      .then((data) => {
        setCombinations(data);
      })
      .catch((error) =>
        console.error("Error fetching currency combinations:", error)
      );
  }, []);
  const handleAddNewCurrency = () => {
    // Validate input
    if (!currencyCode || !currencyName) {
      alert("Please fill in both Currency Code and Currency Name.");
      return;
    }

    // Send a POST request to add the new currency to the database
    fetch("/api/exchange_rates/add/currency", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        currencyCode,
        currencyName,
      }),
    })
      .then((response) => {
        if (response.ok) {
          return response.json();
        } else {
          throw new Error("Currency already exists.");
        }
      })
      .then((data) => {
        alert(`Currency ${data.name} (${data.code}) added successfully.`);
        // Reset the input fields for the new currency
        setCurrencyCode("");
        setCurrencyName("");
      })
      .catch((error) => console.error("Error adding currency:", error));
  };

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
      .catch((error) =>
        console.error("Error adding currency combination:", error)
      );
  };

  const handleDeleteCombination = (id) => {
    // Send a DELETE request to remove the selected combination from the database
    fetch(`/api/exchange_rates/${id}`, {
      method: "DELETE",
    })
      .then((response) => response.json())
      .then(() => {
        // Update the list of combinations by removing the deleted combination
        setCombinations(
          combinations.filter((combination) => combination.id !== id)
        );
      })
      .catch((error) =>
        console.error("Error deleting currency combination:", error)
      );
  };

  const handleEditCombination = (combination) => {
    setSelectedCombination(combination);
    setEditDialogOpen(true);
  };

  const handleSaveEditCombination = () => {
    // Send a PUT request to update the selected combination in the database
    fetch(`/api/exchange_rates/${selectedCombination.id}`, {
      method: "PUT",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        baseCurrency: selectedCombination.base_currency,
        targetCurrency: selectedCombination.target_currency,
        rate: selectedCombination.rate,
      }),
    })
      .then((response) => response.json())
      .then(() => {
        // Update the list of combinations with the edited combination
        setCombinations(
          combinations.map((combination) =>
            combination.id === selectedCombination.id
              ? selectedCombination
              : combination
          )
        );
        // Close the edit dialog
        setEditDialogOpen(false);
      })
      .catch((error) =>
        console.error("Error editing currency combination:", error)
      );
  };

  const handleCancelEditCombination = () => {
    // Reset the selectedCombination and close the edit dialog
    setSelectedCombination(null);
    setEditDialogOpen(false);
  };

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
                    <Button
                      variant="contained"
                      color="primary"
                      onClick={() => handleEditCombination(combination)}
                    >
                      Edit
                    </Button>
                    <Button
                      variant="contained"
                      color="secondary"
                      onClick={() => handleDeleteCombination(combination.id)}
                    >
                      Delete
                    </Button>
                  </TableCell>
                </TableRow>
              ))}
            </TableBody>
          </Table>
        </TableContainer>
      </div>
      <div className="add-currency-big-container">
        <div className="add-currency-small-container">
          <h2>Add New Currency Combination</h2>
          <TextField
            label="From Currency"
            value={baseCurrency}
            onChange={(e) => setBaseCurrency(e.target.value)}
          />
          <TextField
            label="To Currency"
            value={targetCurrency}
            onChange={(e) => setTargetCurrency(e.target.value)}
          />
          <TextField
            label="Rate"
            value={rate}
            onChange={(e) => setRate(e.target.value)}
          />
        </div>
        <Button
          variant="contained"
          color="primary"
          onClick={handleAddCombination}
        >
          Add
        </Button>
      </div>

      <div className="add-new-currency-big-container">
      <h2>Add New Currency</h2>
        <div className="add-new-currency-small-container">
        
        <TextField
          label="Currency"
          value={currencyCode}
          onChange={(e) => setCurrencyCode(e.target.value)}
        />
        <TextField
          label="Currency Name"
          value={currencyName}
          onChange={(e) => setCurrencyName(e.target.value)}
        />
        </div>
        <Button
          variant="contained"
          color="primary"
          onClick={handleAddNewCurrency}
        >
          Add
        </Button>
      </div>

      {/* Edit dialog */}
      <Dialog open={editDialogOpen} onClose={handleCancelEditCombination}>
        <DialogTitle>Edit Currency Combination</DialogTitle>
        <DialogContent className="edit-dialog-container">
          <TextField
            className="edit-dialog-field"
            label="From Currency"
            value={selectedCombination?.base_currency || ""}
            onChange={(e) =>
              setSelectedCombination({
                ...selectedCombination,
                base_currency: e.target.value,
              })
            }
          />
          <TextField
            className="edit-dialog-field"
            label="To Currency"
            value={selectedCombination?.target_currency || ""}
            onChange={(e) =>
              setSelectedCombination({
                ...selectedCombination,
                target_currency: e.target.value,
              })
            }
          />
          <TextField
            className="edit-dialog-field"
            label="Rate"
            value={selectedCombination?.rate || ""}
            onChange={(e) =>
              setSelectedCombination({
                ...selectedCombination,
                rate: e.target.value,
              })
            }
          />
        </DialogContent>
        <DialogActions>
          <Button onClick={handleCancelEditCombination} color="primary">
            Cancel
          </Button>
          <Button onClick={handleSaveEditCombination} color="primary">
            Save
          </Button>
        </DialogActions>
      </Dialog>
    </div>
  );
};

export default CurrencyManagement;
