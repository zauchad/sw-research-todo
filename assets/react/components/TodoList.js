import React, { useState, useEffect } from "react";
import { DragDropContext, Droppable, Draggable } from "react-beautiful-dnd";
import {Todo} from "./Todo";
import axios from "axios";

const initial = Array.from({ length: 10 }, (v, k) => k).map(k => {
    return {
        id: `id-${k}`,
        content: `Quote ${k}`
    };
});

const reorder = (list, startIndex, endIndex) => {
    const result = Array.from(list);
    const [removed] = result.splice(startIndex, 1);
    result.splice(endIndex, 0, removed);

    return result;
};

function TodoList() {
    const [state, setState] = useState({ quotes: initial });

    useEffect(() => {
        console.log('TodoList did mount/updated');

        axios.get('/api/todos')
            .then(function (response) {
                // handle success
                console.log('success', response);
            })
            .catch(function (error) {
                // handle error
                console.log('error', error);
            })
            .then(function () {
                // always executed
                console.log('then always executed');
            });
    });

    function onDragEnd(result) {
        console.log(
            result.source.index,
            result.destination.index,
        );

        if (!result.destination) {
            return;
        }

        if (result.destination.index === result.source.index) {
            return;
        }

        const quotes = reorder(
            state.quotes,
            result.source.index,
            result.destination.index
        );

        setState({ quotes });
    }

    return (
        <DragDropContext onDragEnd={onDragEnd}>
            <Droppable droppableId="list">
                {provided => (
                    <div ref={provided.innerRef} {...provided.droppableProps}>
                        {
                            state.quotes.map((quote, index) => (
                                <Draggable draggableId={quote.id} index={index} key={quote.id}>
                                    {provided => (
                                        <Todo
                                            innerRef={provided.innerRef}
                                            {...provided.draggableProps}
                                            {...provided.dragHandleProps}
                                        >
                                            {quote.content}
                                        </Todo>
                                    )}
                                </Draggable>
                            ))
                        }
                        {provided.placeholder}
                    </div>
                )}
            </Droppable>
        </DragDropContext>
    );
}

export {TodoList};