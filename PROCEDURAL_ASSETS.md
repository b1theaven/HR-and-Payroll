You are an expert Unity C# graphics programmer and procedural mesh developer.

Write a set of production-ready, clean, and well-documented C# scripts for Unity (URP compatible) that procedurally generate 3D meshes for PC hardware components without using external 3D models or asset files.

### TECHNICAL REQUIREMENTS:

1. Engine & Pipeline: Unity 2022+ / Unity 6 using Universal Render Pipeline (URP).
2. Architecture:
   - Base Class / Interface: Create a base script or interface `ProceduralPCComponent` that inherits from `MonoBehaviour`.
   - Mesh Construction: Generate vertices, triangles, normals, UVs programmatically, and build `Mesh` objects dynamically via script.
   - Material & Colors: Create standard URP PBR materials programmatically (`Shader.Find("Universal Render Pipeline/Lit")`) with distinct color palettes and metallic/smoothness parameters for functional identification.

### COMPONENTS TO GENERATE PROCEDURALLY:

1. Motherboard (`ProceduralMotherboard.cs`):
   - Base PCB slab with dark gray/black material.
   - CPU Socket (metallic latch area).
   - 4x RAM DIMM Slots (dual-color pairs, e.g., blue & black).
   - 2x PCIe Slots (metallic/red accent).
   - Rear I/O Shield block.

2. CPU & CPU Cooler (`ProceduralCPU.cs` & `ProceduralCPUCooler.cs`):
   - CPU: Flat square metallic plate with gold contacts/corner notch indicator.
   - CPU Cooler: Heatsink block with extruded vertical fins and a top circular fan cylinder frame.

3. RAM Stick (`ProceduralRAM.cs`):
   - Thin rectangular PCB slab with bottom notch and metallic heat spreader side plates.

4. GPU / Graphics Card (`ProceduralGPU.cs`):
   - Extended PCIe dual-slot body with bottom connector strip, side power ports, and 2-3 fan recesses/cylinders on the front face.

5. Power Supply Unit / PSU (`ProceduralPSU.cs`):
   - Matte black cubic enclosure with rear power socket mesh cutout, power switch box, and front modular cable output ports.

6. PC Case (`ProceduralPCCase.cs`):
   - Outer frame structure with cutouts.
   - Detachable side glass panel (semi-transparent material with alpha blend).
   - Internal motherboard tray with screw standoff indicators.

### CODE STRUCTURE REQUIREMENTS:

- Provide an editor utility or context menu function `[ContextMenu("Generate Mesh")]` on each script so components can be generated and rendered both in Play Mode and Edit Mode.
- Add `MeshCollider` automatically after generating geometry to allow Raycast targeting for assembly interaction.
- Ensure proper UV mapping for basic texturing and clean recalculated normals/tangents (`mesh.RecalculateNormals()`, `mesh.RecalculateBounds()`).
- Output all code in well-structured, complete C# files without placeholder code or `// TODO` comments.
