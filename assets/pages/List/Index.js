import React from 'react';
import { createRoot } from 'react-dom/client';

import './List.scss';
import {TodoListPage} from '../../react/pages/TodoListPage';

const container = document.getElementById('app');
const root = createRoot(container);

root.render(<TodoListPage />);

console.log('List/Index.js');