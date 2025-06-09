package main

import (
	"errors"
	"fmt"
	"strings"
)

type TodoStatus string

const PENDING TodoStatus = "pending"
const DOING TodoStatus = "doing"
const DONE TodoStatus = "done"

type Todo struct {
	id     int
	title  string
	status TodoStatus
}

func (t *Todo) Pending() *Todo {
	t.status = PENDING

	return t
}

func (t *Todo) Doing() *Todo {
	t.status = DOING

	return t
}

func (t *Todo) Done() *Todo {
	t.status = DONE

	return t
}

func (t *Todo) ToString() string {
	return fmt.Sprintf("{ id: %d, title: %s, status: %s } \n", t.id, t.title, t.status)
}

type TodoManager struct {
	debug  bool
	todos  map[int]Todo
	length int
}

func (m *TodoManager) Get(id int) (*Todo, error) {
	todo, ok := m.todos[id]
	if !ok {
		return nil, errors.New(fmt.Sprintf("Todo[%d] not found", id))
	}

	return &todo, nil
}

func (m *TodoManager) Add(title string, status TodoStatus) *Todo {
	id := m.length + 1
	todo := Todo{id, title, status}

	if m.debug {
		fmt.Printf("Adding new %s\n", todo.ToString())
	}

	m.length = id
	m.todos[id] = todo
	return &todo
}

func (m *TodoManager) Update(todo *Todo) *TodoManager {

	from := m.todos[todo.id]

	if m.debug {
		fmt.Printf("Updating todo from %s => %s\n", from.ToString(), todo.ToString())
	}

	m.todos[todo.id] = *todo

	return m
}

func (m *TodoManager) Remove(todo *Todo) *TodoManager {
	if m.debug {
		fmt.Printf("Removing todo %s\n", todo.ToString())
	}
	m.length = m.length - 1
	delete(m.todos, todo.id)
	return m
}

func (m *TodoManager) All() []Todo {

	items := make([]Todo, m.length)

	for _, todo := range m.todos {
		items[todo.id-1] = todo
	}

	return items
}

func (m *TodoManager) ToString() string {
	str := []string{"TodoManager ["}

	for _, todo := range m.All() {
		str = append(str, fmt.Sprintf("  %s", todo.ToString()))
	}

	str = append(str, "]")
	return strings.Join(str, "\n")
}

func NewTodoManager(debug bool) *TodoManager {
	return &TodoManager{
		debug:  debug,
		todos:  make(map[int]Todo),
		length: 0,
	}
}
