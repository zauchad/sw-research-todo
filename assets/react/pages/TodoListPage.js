import React, {useState, useEffect} from 'react';
import {TodoList} from "../components/TodoList";
import axios from "axios";

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
            <h2 className="mb-4">SW Research TODO list</h2>
                <CreateTodoButton refreshHandler={refreshTodos}/>
                <div>
                    <TodoList quotes={state.quotes} refreshHandler={refreshTodos}/>
                </div>
        </div>
    );
};

const CreateTodoButton = ({refreshHandler}) => {
    const [state, setState] = useState({name: ''});

    const handleSubmit = e => {
        e.preventDefault();
        if (!state.name) return;

        axios.post('/api/todo', {
            name: state.name,
        })
            .then(function (response) {
                refreshHandler();
                console.log('success', response);
            })
            .catch(function (error) {
                // handle error
                console.log('error', error);
            })
            .then(function () {
                setState({
                    name: '',
                });
            });
    }

    return (
        <div className="d-flex justify-content-end align-items-center mb-3">
            <button type="button" className="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Add
            </button>

            <div className="modal fade" id="exampleModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div className="modal-dialog">
                    <div className="modal-content">
                        <div className="modal-header">
                            <h5 className="modal-title" id="exampleModalLabel">Modal title</h5>
                        </div>
                        <div className="modal-body">
                            <form onSubmit={handleSubmit}>
                                <div className="mb-3">
                                    <label htmlFor="todoNameHtml" className="form-label">Name</label>
                                    <input onChange={e => setState({name: e.target.value})} value={state.name} type="text" className="form-control" id="todoNameHtml" aria-describedby="nameHelp" placeholder="Add a new task" />
                                    <div id="nameHelp" className="form-text">Type TODO name</div>
                                </div>
                                <button type="submit" className="btn btn-success">Add</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
};

export {TodoListPage};