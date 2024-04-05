import React, { useState, useEffect } from 'react';
import axios from 'axios';
import UserList from './components/UserList';
import CreateUser from './components/CreateUser';
import UpdateUser from './components/UpdateUser';
import DeleteUser from './components/DeleteUser';

function App() {
    const [users, setUsers] = useState([]);
    const [selectedUser, setSelectedUser] = useState(null);

    useEffect(() => {
        axios.get('http://localhost:8000/users')
            .then(response => {
                setUsers(response.data);
            })
            .catch(error => {
                console.error('Error fetching users:', error);
            });
    }, []);

    const handleUserCreated = (newUser) => {
        setUsers(prevUsers => [...prevUsers, newUser]);
    };

    const handleUserUpdated = (updatedUser) => {
        setUsers(prevUsers => prevUsers.map(user => user.id === updatedUser.id ? updatedUser : user));
        setSelectedUser(null);
    };

    const handleUserDeleted = (deletedUser) => {
        setUsers(prevUsers => prevUsers.filter(user => user.id !== deletedUser.id));
        setSelectedUser(null);
    };

    const handleEditUser = (user) => {
        setSelectedUser(user);
    };

    return (
        <div className="App">
            <h1>User Management System</h1>
            <UserList users={users} onEditUser={handleEditUser} onDeleteUser={handleUserDeleted} />
            <CreateUser onUserCreated={handleUserCreated} />
            {selectedUser && <UpdateUser user={selectedUser} onUpdate={handleUserUpdated} />}
            {selectedUser && <DeleteUser user={selectedUser} onDelete={handleUserDeleted} />}
        </div>
    );
}

export default App;
