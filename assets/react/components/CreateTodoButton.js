import React, { useState } from 'react';
import axios from 'axios';
import toast from 'react-hot-toast';

function CreateTodoButton({ refreshHandler }) {
  const [state, setState] = useState({ name: '' });

  const handleSubmit = (e) => {
    e.preventDefault();
    if (!state.name) return;

    axios.post('/api/todo', {
      name: state.name,
    })
      .then(() => {
        refreshHandler();
        toast.success('TODO has been created!');
      })
      .catch((error) => {
        toast.error(error.response.data.error);
      })
      .then(() => {
        setState({
          name: '',
        });
      });
  };

  return (
    <div className="d-flex justify-content-end align-items-center mb-3">
      <button type="button" className="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Create
      </button>

      <div className="modal fade" id="exampleModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div className="modal-dialog">
          <div className="modal-content">
            <div className="modal-header">
              <h5 className="modal-title" id="exampleModalLabel">Create TODO</h5>
            </div>
            <div className="modal-body">
              <form onSubmit={handleSubmit}>
                <div className="mb-3">
                  <label htmlFor="todoNameHtml" className="form-label">Name</label>
                  <input onChange={(e) => setState({ name: e.target.value })} value={state.name} type="text" className="form-control" id="todoNameHtml" aria-describedby="nameHelp" placeholder="Add a new task" />
                  <div id="nameHelp" className="form-text">Type TODO name</div>
                </div>
                <div className="d-flex justify-content-between align-items-center">
                  <button type="button" className="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" className="btn btn-success">Add</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}

export { CreateTodoButton };
