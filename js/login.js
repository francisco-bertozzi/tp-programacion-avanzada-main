const inputs = document.querySelectorAll("input[name]")

inputs.forEach((i) => {
  i.addEventListener("invalid", () => {
    i.setAttribute("aria-invalid", true)
  })
  i.addEventListener("input", () => {
    i.removeAttribute("aria-invalid")
  })
})
