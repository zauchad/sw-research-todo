import React, {useState, useEffect} from 'react';
import {TodoList} from "../components/TodoList";
import { Toaster } from 'react-hot-toast';
import axios from "axios";
import {CreateTodoButton} from "../components/CreateTodoButton";

const TodoListPage = () => {
    const [state, setState] = useState({ quotes: [] });

    useEffect(() => {
        refreshTodos();
    }, []);

    const refreshTodos = () => {
        axios.get('/api/todos')
            .then(function (response) {
                const quotes = response.data;

                quotes.sort((a, b) => a.position > b.position )

                setState({
                    quotes: quotes
                });
            });
    };

    return (
        <div className="container-xxl py-4">
            <Toaster />
            <h2 className="mb-4">SW Research TODO list</h2>
            <CreateTodoButton refreshHandler={refreshTodos}/>
            <div>
                <TodoList quotes={state.quotes} refreshHandler={refreshTodos}/>
            </div>
        </div>
    );
};

export {TodoListPage};