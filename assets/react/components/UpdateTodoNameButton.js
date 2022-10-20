import React, { useState } from 'react';
import axios from 'axios';
import toast from 'react-hot-toast';

function UpdateTodoNameButton({ id, refreshHandler }) {
  const [state, setState] = useState({ name: '' });

  const handleSubmit = (e) => {
    e.preventDefault();
    if (!state.name) return;

    axios.put('/api/todo/name', {
      id,
      name: state.name,
    })
      .then(() => {
        refreshHandler();
        toast.success('TODO name has been updated!');
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
                  <input onChange={(e) => setState({ name: e.target.value })} value={state.name} type="text" className="form-control" id="todoNameHtml" aria-describedby="nameHelp" placeholder="Add a new task" />
                  <div id="nameHelp" className="form-text">Type TODO name</div>
                </div>
                <div className="d-flex justify-content-between align-items-center">
                  <button type="button" className="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" className="btn btn-warning">Update</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}

export { UpdateTodoNameButton };
