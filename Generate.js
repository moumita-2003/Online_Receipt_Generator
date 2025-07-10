function generateBill() {
    const billNo = document.getElementById("bill-no").value;
    const totalAmount = parseFloat(document.getElementById("total-amount").textContent);
  
    // Send AJAX request to store the total and retrieve products
    fetch(`GenerateBill.php?billNo=${billNo}&totalAmount=${totalAmount}`)
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          displayProducts(data.products); // Display products from the response
        } else {
          alert("Error generating bill.");
        }
      });
  }
  
  // Function to display products on the page
  function displayProducts(products) {
    const tableBody = document.querySelector("#product-table tbody");
    tableBody.innerHTML = ""; // Clear current table
  
    products.forEach(product => {
      const row = document.createElement("tr");
  
      row.innerHTML = `
        <td>${product.name}</td>
        <td>${product.price}</td>
        <td>${product.gst}</td>
        <td>${product.quantity}</td>
        <td>${product.total}</td>
        <td><button onclick="removeProduct(${product.id}, this)">Remove</button></td>
      `;
  
      tableBody.appendChild(row);
    });
  }
  