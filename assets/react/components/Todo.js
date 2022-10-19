import React from 'react';

const Todo = ({name}) => (
    <div className="card mb-3 w-75 m-auto">
        <div className="card-body d-flex justify-content-between align-items-center">
            <h5 className="card-title d-inline-block me-2">{name}</h5>
            <a href="#" className="d-inline-block btn btn-primary">Update</a>
        </div>
    </div>
);

export {Todo};