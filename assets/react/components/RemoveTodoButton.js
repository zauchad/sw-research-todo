import React from "react";
import axios from "axios";
import { Modal } from "bootstrap";
import toast from "react-hot-toast";

function RemoveTodoButton({ id, refreshHandler }) {
  const handleSubmit = (e) => {
    e.preventDefault();

    axios.delete(`/api/todo/${id}`).then(() => {
      refreshHandler();
      Modal.getInstance(document.getElementById(`todoRemoveModal${id}`)).hide();

      toast.success("TODO has been removed!");
    });
  };

  return (
    <div className="d-flex justify-content-end align-items-center mb-3">
      <button
        type="button"
        className="btn btn-danger"
        data-bs-toggle="modal"
        data-bs-target={`#todoRemoveModal${id}`}
      >
        Remove
      </button>

      <div
        className="modal fade"
        id={`todoRemoveModal${id}`}
        aria-labelledby={`todoRemoveModalLabel${id}`}
        aria-hidden="true"
      >
        <div className="modal-dialog">
          <div className="modal-content">
            <div className="modal-header">
              <h5 className="modal-title" id={`todoRemoveModalLabel${id}`}>
                Are you sure to remove?
              </h5>
            </div>
            <div className="modal-body">
              <form
                onSubmit={handleSubmit}
                className="d-flex justify-content-between align-items-center"
              >
                <button
                  type="button"
                  className="btn btn-secondary"
                  data-bs-dismiss="modal"
                >
                  No
                </button>
                <button type="submit" className="btn btn-danger">
                  Yes
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}

export { RemoveTodoButton };
