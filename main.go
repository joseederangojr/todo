package main

import (
	"fmt"
)

func main() {
	m := NewTodoManager(true)
	finish := m.Add("Finish golings", PENDING)
	learn := m.Add("Learn Go", PENDING)
	basic := m.Add("Create basic go todo app", PENDING)
	build := m.Add("Build HTTP Server", PENDING)

	fmt.Println(m.ToString())

	m.
		Update(finish.Done()).
		Update(learn.Doing()).
		Update(basic.Doing()).
		Remove(build)

	fmt.Println(m.ToString())
}
