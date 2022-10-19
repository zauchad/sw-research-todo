import React, {useState} from 'react';
import { unmountComponentAtNode } from "react-dom";
import axios from "axios";
import {Modal} from "bootstrap";

const Todo = (props) => {
    // console.log('Todo props:', props);
    return (
        <div ref={props.innerRef} className="card mb-3 m-auto" {...props}>
            <div className="card-body d-flex justify-content-between align-items-center">
                <h5 className="card-title d-inline-block me-2">{props.name}</h5>
                <div>
                    <UpdateNameTodoButton id={props.id} refreshHandler={props.refreshHandler}/>
                    <RemoveTodoButton id={props.id} refreshHandler={props.refreshHandler}/>
                </div>
            </div>
        </div>
    );
};

const UpdateNameTodoButton = ({id, refreshHandler}) => {
    const [state, setState] = useState({name: ''});

    const handleSubmit = e => {
        e.preventDefault();
        if (!state.name) return;

        axios.put('/api/todo/name', {
            id: id,
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
            <button type="button" className="btn btn-warning" data-bs-toggle="modal" data-bs-target={`#todoUpdateNameModal${id}`}>
                Update name
            </button>

            <div className="modal fade" id={`todoUpdateNameModal${id}`} aria-labelledby={`todoUpdateNameModalLabel${id}`} aria-hidden="true">
                <div className="modal-dialog">
                    <div className="modal-content">
                        <div className="modal-header">
                            <h5 className="modal-title" id={`todoUpdateNameModalLabel${id}`}>Update name</h5>
                        </div>
                        <div className="modal-body">
                            <form onSubmit={handleSubmit}>
                                <div className="mb-3">
                                    <label htmlFor="todoNameHtml" className="form-label">Name</label>
                                    <input onChange={e => setState({name: e.target.value})} value={state.name} type="text" className="form-control" id="todoNameHtml" aria-describedby="nameHelp" placeholder="Add a new task" />
                                    <div id="nameHelp" className="form-text">Type TODO name</div>
                                </div>
                                <button type="submit" className="btn btn-warning">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
};

const RemoveTodoButton = ({id, refreshHandler}) => {
    const handleSubmit = e => {
        e.preventDefault();

        axios.delete(`/api/todo/${id}`)
            .then(function (response) {
                refreshHandler();
                console.log('success', response);

                Modal.getInstance(
                    document.getElementById(`todoRemoveModal${id}`)
                ).hide();
            });
    }

    return (
        <div className="d-flex justify-content-end align-items-center mb-3">
            <button type="button" className="btn btn-danger" data-bs-toggle="modal" data-bs-target={`#todoRemoveModal${id}`}>
                Remove
            </button>

            <div className="modal fade" id={`todoRemoveModal${id}`} aria-labelledby={`todoRemoveModalLabel${id}`} aria-hidden="true">
                <div className="modal-dialog">
                    <div className="modal-content">
                        <div className="modal-header">
                            <h5 className="modal-title" id={`todoRemoveModalLabel${id}`}>Remove TODO</h5>
                        </div>
                        <div className="modal-body">
                            <form onSubmit={handleSubmit}>
                                <button type="submit" className="btn btn-danger">Remove</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
};

export {Todo};