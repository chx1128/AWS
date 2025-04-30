/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/javascript.js to edit this template
 */

// Sample member data
const members = [
    {id: "001", name: "Ahmad bin Abdullah", email: "ahmadabdullah@gmail.com", phone: "012-3456789"},
    {id: "002", name: "Aishah bt. Ahmad", email: "aishah@gmail.com", phone: "016-5432109"},
    {id: "003", name: "Amirul Hakim bin Razali", email: "amirulhakim@gmail.com", phone: "012-3456789"},
    {id: "004", name: "Arif bin Zainal", email: "arifzainal@gmail.com", phone: "012-3456789"},
    {id: "005", name: "Chong Kok Weng", email: "kokwengchong@gmail.com", phone: "011-21345678"},
    {id: "006", name: "Goh Mei Yen", email: "meiyengoh@gmail.com", phone: "013-9876543"},
    {id: "007", name: "Hafizah binti Zakaria", email: "hafizahzakaria@gmail.com", phone: "015-87654832"},
    {id: "008", name: "Kavita Rajoo", email: "kavitarajoo@gmail.com", phone: "015-8765432"},
    {id: "009", name: "Koh Jia Hui", email: "jhkoh@gmail.com", phone: "013-9876543"},
    {id: "010", name: "Lee Ming Xuan", email: "mxlee@gmail.com", phone: "011-23455578"},
    {id: "011", name: "Lim Chee Seng", email: "chee.seng@gmail.com", phone: "014-8765432"},
    {id: "012", name: "Lim Wei Jie", email: "wei.jie@gmail.com", phone: "019-8765432"},
    {id: "013", name: "Mohamad Fitri bin Ahmad", email: "mohamad.fitri@gmail.com", phone: "015-87665432"},
    {id: "014", name: "Mohd Azman bin Yusof", email: "mohd.azman@gmail.com", phone: "017-6543210"},
    {id: "015", name: "Mohd Faizal bin Aziz", email: "mohd.faizal@gmail.com", phone: "017-6543210"},
    {id: "016", name: "Mohd Faisal bin Yusof", email: "mohd.faisal@gmail.com", phone: "017-6543210"},
    {id: "017", name: "Muhammad Haris bin Ibrahim", email: "muhammad.haris@gmail.com", phone: "014-8765432"},
    {id: "018", name: "Nurul Aisyah binti Rahman", email: "nurul.aisyah@gmail.com", phone: "011-23456178"},
    {id: "019", name: "Nurul Izzati bt. Ismail", email: "nurul.izzati@gmail.com", phone: "016-5432109"},
    {id: "020", name: "Norazimah bt. Hassan", email: "norazimah@gmail.com", phone: "010-9876543"},
    {id: "021", name: "Norazlina bt. Mohamad", email: "norazlina.mohamad@gmail.com", phone: "018-7654321"},
    {id: "022", name: "Norshafika binti Sulaiman", email: "norshafika@gmail.com", phone: "019-8765432"},
    {id: "023", name: "Siti Fatimah bt. Ismail", email: "siti.fatimah@gmail.com", phone: "013-9876543"},
    {id: "024", name: "Siti Norhidayah binti Hashim", email: "siti.norhidayah@gmail.com", phone: "018-7654321"},
    {id: "025", name: "Siti Nurul Huda binti Roslan", email: "siti.nurul.huda@gmail.com", phone: "019-8765432"},
    {id: "026", name: "Tan Mei Ling", email: "mei.ling@gmail.com", phone: "016-5432109"},
    {id: "027", name: "Tan Ming Wei", email: "ming.wei@gmail.com", phone: "010-9876543"},
    {id: "028", name: "Tan Wei Lun", email: "wei.lun@gmail.com", phone: "010-9876543"},
    {id: "029", name: " Wong Kok Keong", email: "kok.keong@gmail.com", phone: "014-8765432"},
    {id: "030", name: "Wong Li Wei", email: "li.wei@gmail.com", phone: "018-7654321"}
];

// Function to populate table with member data
function populateTable() {
    const tbody = document.querySelector('#member-table tbody');
    // Clear existing rows
    tbody.innerHTML = '';

    members.forEach((member, index) => {
        const row = document.createElement('tr');
        row.innerHTML = `
                <td>${member.id}</td>
                <td>${member.name}</td>
                <td>${member.email}</td>
                <td>${member.phone}</td>
                <td><button class="delete-btn" onclick="deleteMember(${index})">Delete</button></td>
            `;
        tbody.appendChild(row);
    });
}

// Function to delete a member
function deleteMember(index) {
    if (confirm("Are you sure you want to delete this member?")) {
        // Remove member from array
        members.splice(index, 1);

        // Reassign IDs for members following the deleted member
        for (let i = index; i < members.length; i++) {
            //// Increment IDs by 1 and pad with zero
            members[i].id = padZero(i + 1);
        }

        populateTable();
    }
}

// Function to add a new member
function addMember() {
    // Loop until valid input for all fields or cancel button clicked
    while (true) {
        // Prompt user to enter member details with default ID
        let id, name, email, phone;
        let isValid = false;

        // Retrieve the last member's ID
        let lastMemberId = members.length > 0 ? members[members.length - 1].id : 0;

        // Increment the last member's ID
        let newId = parseInt(lastMemberId) + 1;
        
        // Set default ID
        id = padZero(newId);

        // Validate and prompt for name
        while (!isValid) {
            name = prompt("Enter Member Name:");
            if (name === null)
                return; 
            isValid = name && /^[\w\s]+$/.test(name);
            if (!isValid)
                alert("Please enter a valid Member Name.");
        }

        isValid = false; 

        // Validate and prompt for email
        while (!isValid) {
            email = prompt("Enter Email Address:");
            if (email === null)
                return;
            isValid = email && /^[\w.-]+@[\w.-]+\.\w{2,6}$/.test(email);
            if (!isValid)
                alert("Please enter a valid Email Address.");
        }

        isValid = false;

        // Validate and prompt for phone number
        while (!isValid) {
            phone = prompt("Enter Phone Number:");
            if (phone === null)
                return; 
            isValid = phone && /^01[0-9]-\d{7,8}$/.test(phone);
            if (!isValid)
                alert("Please enter a valid Phone Number in the format 01X-XXXXXXX.");
        }

        const newMember = {id, name, email, phone};

        // Find the correct position to insert the new member in the sorted list
        let index = 0;
        while (index < members.length && name.localeCompare(members[index].name) >= 0) {
            index++;
        }

        // Insert the new member at the correct position
        members.splice(index, 0, newMember);

        // Update the IDs of all members
        for (let i = 0; i < members.length; i++) {
            members[i].id = padZero(i + 1);
        }

        // Update the table
        populateTable();

        break;
    }
}

// Function to pad single-digit IDs with leading zeros
function padZero(id) {
    return id.toString().padStart(3, '0');
}

// Populate table on page load
window.onload = populateTable;