# Product Requirement Document (PRD): 3D PC Building Simulator (Static Room)

## 1. Project Overview

- **Project Name:** PC Assembly Simulator Lite
- **Platform Target:** PC (Windows / Standalone)
- **Engine:** Unity (Universal Render Pipeline - URP)
- **Goal:** A 3D interactive application simulating step-by-step PC hardware assembly with detailed mechanics (cables, screws, zoom interaction) in a fixed/static room environment.

---

---

## 2. Core Features & Scope

1. **Static Environment:**

- Player cannot freely walk around (_no FPS movement_).
- Fixed workbench/desk environment inside a bedroom setting.
- Orbital & Zoom-based camera focused on the PC case / workbench.

2. **Camera Controls:**

- Left-click + Drag: Orbit camera around the PC case.
- Mouse Scroll: Zoom in / Zoom out to inspect components closely (RAM, CPU, Cables, Screws).
- Focus Mode: Double-click a component or socket to center the camera on it.

3. **Detailed Assembly System:**

- **Component Dependency Logic:** Components must be installed in logical order (e.g., CPU must be placed before CPU Cooler; Motherboard screws must be installed before GPU).
- **Screwing Mechanics:** Click-and-hold or click interaction to tighten/loosen screws for Case Covers, Motherboard, PSU, and Expansion Slots.
- **Cabling Mechanics:** Connect 2-pin / 4-pin / 8-pin / 24-pin power and SATA cables from PSU/Motherboard to target components.
- **Boot Check:** A "Power On" button to verify if all required components, screws, and power cables are properly connected.

4. **Component List (Initial Core Assets):**

- PC Case (with removable side panels and screws)
- Motherboard (with CPU latch, RAM slots, PCIe slots)
- CPU & CPU Fan / Cooler
- RAM Sticks (2x)
- GPU / Graphics Card
- Storage: 2.5" SSD and 3.5" HDD
- Power Supply Unit (PSU) + Cable Harness
- Case Fans (Front/Rear)

---

## 3. Asset & Visual Instructions for Antigravity

> **Important:** The developer/AI must generate initial 3D models procedurally using Unity primitives (`GameObject.CreatePrimitive`) or custom mesh generation scripts with distinct materials/colors for functional identification.

```text
[Procedural Asset Guidelines]
- PC Case: Rectangular Mesh, dark gray material, semi-transparent side panel.
- Motherboard: Flat green/black rectangle with distinct colored sockets (Blue for RAM, Red for PCIe).
- CPU: Small square plate with a top metallic latch object.
- RAM/GPU: Rectangular boards with bottom connector pins.
- Screws: Small cylindrical objects with a distinct metallic texture/color.
- Cables: LineRenderer components with snap points on sockets.

```

---

## 4. Technical Requirements & Architecture

1. **Interaction System:**

- Use Unity's **New Input System** or standard Raycasting for selecting objects.
- Implement a `SnapPoint` script for target sockets (CPU Socket, RAM Slots, Cable Ports).

2. **State Machine / Manager:**

- `AssemblyManager.cs`: Controls component installation states, dependency validation, and PC Boot-up check.
- `CameraController.cs`: Handles orbit, pan, clamp-zoom boundaries, and smooth focusing.
- `CableManager.cs`: Uses `LineRenderer` or simple procedural Splines to connect point A (PSU/MB) to point B (Target Component).

3. **UI / HUD Requirements:**

- Inventory/Part Selector Panel (Bottom UI) to select parts to install.
- Tool Switcher UI: Toggle between "Hand Mode" (Parts), "Screwdriver Mode" (Screws), and "Cable Mode" (Wiring).
- Status Overlay: Indicates missing connections when trying to power on.

---

## 5. Definition of Done (MVP Criteria)

- [ ] Camera smoothly orbits and zooms in on specific parts of the PC case without clipping into geometry.
- [ ] Player can attach and remove at least Motherboard, CPU, RAM, GPU, PSU, and 1 Drive.
- [ ] Screws must be fastened to secure the Motherboard and PSU in place.
- [ ] Power cables must be connected to Motherboard (24-pin), CPU (8-pin), and GPU (6/8-pin).
- [ ] Pressing the Power Button triggers a "Success / Booted" visual indicator if all connections are valid.

---
