import tkinter as tk
from tkinter import ttk
from tkinter import *
from tkinter.ttk import *
from tkinter import messagebox
import datetime
from PIL import Image, ImageTk
import json
import os

# File untuk menyimpan data
DATA_FILE = "project_data.json"
DELETED_DATA_FILE = "deleted_data.json"

# Fungsi untuk memuat data dari file JSON
def load_data(file_path):
    if os.path.exists(file_path):
        with open(file_path, "r") as file:
            return json.load(file)
    return []

# Fungsi untuk menyimpan data ke file JSON
def save_data(file_path, data):
    with open(file_path, "w") as file:
        json.dump(data, file)

# List to store deleted data
def add_data_to_table(project_name, customer, due_date):
    # Tambah data ke tabel dengan warna baris bergantian
    row_count = len(table.get_children())
    row_color = "#d0f0c0" if row_count % 2 == 0 else "#ffffff"
    table.insert("", "end", values=(project_name, customer, due_date), tags=(row_color,))
    table.tag_configure(row_color, background=row_color)

def open_form_popup():
    """Function to open a pop-up form for data input."""
    popup = tk.Toplevel()
    popup.title("Add Project Data")
    popup.geometry("500x200")

    # Form labels and entry fields in the popup
    tk.Label(popup, text="Project Name:").grid(row=0, column=0, padx=5, pady=5, sticky="e")
    entry_project_name = tk.Entry(popup, width=30)
    entry_project_name.grid(row=0, column=1, padx=5, pady=5)

    tk.Label(popup, text="Customer:").grid(row=1, column=0, padx=5, pady=5, sticky="e")
    entry_customer = tk.Entry(popup, width=30)
    entry_customer.grid(row=1, column=1, padx=5, pady=5)

    tk.Label(popup, text="Due Date:").grid(row=2, column=0, padx=5, pady=5, sticky="e")
    entry_due_date = tk.Entry(popup, width=30)
    entry_due_date.grid(row=2, column=1, padx=5, pady=5)
    def submit_data():
        project_name = entry_project_name.get()
        customer = entry_customer.get()
        due_date = entry_due_date.get()

        if not project_name or not customer or not due_date:
            messagebox.showwarning("Input Error", "All fields are required!", parent=popup)
            return

        add_data_to_table(project_name, customer, due_date)
        save_data(DATA_FILE, get_all_table_data())
        popup.destroy()

    tk.Button(popup, text="Submit", command=submit_data).grid(row=3, columnspan=2, pady=10)

# Fungsi untuk mendapatkan semua data dari tabel
def get_all_table_data():
    return [table.item(item, "values") for item in table.get_children()]

def delete_selected_data():
    selected_items = table.selection()
    if not selected_items:
        messagebox.showwarning("Delete Error", "No item selected to delete!")
        return

    deleted_data = load_data(DELETED_DATA_FILE)

    for item in selected_items:
        deleted_data.append(table.item(item, "values"))
        table.delete(item)

    save_data(DATA_FILE, get_all_table_data())
    save_data(DELETED_DATA_FILE, deleted_data)
    messagebox.showinfo("Delete Success", "Selected item(s) deleted successfully.")

# Fungsi untuk melihat data yang dihapus
def view_deleted_data():
    deleted_data = load_data(DELETED_DATA_FILE)
    if not deleted_data:
        messagebox.showinfo("No Data", "No deleted data to show.")
        return

    popup = tk.Toplevel()
    popup.title("Deleted Data")
    popup.geometry("1000x400")

    # Membuat tabel untuk data yang dihapus
    deleted_table = ttk.Treeview(popup, columns=("Project Name", "Customer", "Due Date"), show="headings")
    deleted_table.heading("Project Name", text="Project Name")
    deleted_table.heading("Customer", text="Customer")
    deleted_table.heading("Due Date", text="Due Date")
    deleted_table.pack(fill="both", expand=True, padx=10, pady=10)

    for data in deleted_data:
        deleted_table.insert("", "end", values=data)

    def delete_selected_permanently():
        selected_items = deleted_table.selection()
        if not selected_items:
            messagebox.showwarning("Delete Error", "No item selected to delete!")
            return

        remaining_data = []
        for item in deleted_table.get_children():
            if item not in selected_items:
                remaining_data.append(deleted_table.item(item, "values"))

        # Update file with remaining data
        save_data(DELETED_DATA_FILE, remaining_data)

        # Refresh tabel
        for item in selected_items:
            deleted_table.delete(item)

        messagebox.showinfo("Delete Success", "Selected item(s) deleted permanently.")
     # Tombol untuk menghapus data terpilih
    tk.Button(popup, text="Delete Selected Permanently", command=delete_selected_permanently).pack(pady=10)

# Memuat data utama ke tabel
def populate_table():
    data = load_data(DATA_FILE)
    for row in data:
        add_data_to_table(*row)

#time Update
def update_time():
    """Update the current time displayed on the top right."""
    now = datetime.datetime.now().strftime("%Y-%m-%d %H:%M:%S")
    time_label.config(text=now)
    root.after(1000, update_time)

# Create the main window
root = tk.Tk()
root.title("Project Management Table")

# Set window to fullscreen size
screen_width = root.winfo_screenwidth()
screen_height = root.winfo_screenheight()
root.attributes('-fullscreen', True)
root.configure(bg="#414142")

#logo
canvas= Canvas(root, width= 170, height= 100,bd=0, highlightthickness=0, bg="#414142")
canvas.grid(row=0, column=0, padx=10, pady=5,sticky="w",)
image= Image.open("Logo_EID V1.png")
image = image.resize((200, 100))
pic = ImageTk.PhotoImage(image)
canvas.create_image(5,5,anchor=NW,image=pic)
#title
title_canvas = Canvas(root, width= 1000, height= 100,bd=0, highlightthickness=0, bg="#414142")
title_canvas.grid(row=0, column=1,columnspan=2, padx=0, pady=5,sticky="s",)
title_canvas.create_text(500, 50, text="UNDONE SCHEDULE", font=("Tahoma", 35, "bold"), fill="white")
#ime & date
time_bg = ImageTk.PhotoImage(Image.open("background_warna_V3.png").resize((370, 50)))
time_label = tk.Label(root, compound= tk.CENTER,font=("Arial", 25, "bold"),foreground="white",background="#414142", image= time_bg)
time_label.grid(row=0, column=3, padx=40, pady=5, sticky="")
update_time()

# Create the table frame
table_frame = tk.Frame(root, bg="#414142",padx=20, pady=5, border=0)
table_frame.grid(row=1, column=0, columnspan=4, padx=20, pady=5, sticky="nsew")

# Create the table
style = ttk.Style()
style.theme_use("clam")
style.configure("Treeview", background="white", font=("Arial",15),foreground="black", rowheight=25, fieldbackground="#a9d08e")
style.configure("Treeview.Heading",background="#3DA769",font=("arial",18,"bold"),foreground="white", fieldbackground="#a9d08e")
style.map('Treeview',background=[('selected', '#38761d')])
table = ttk.Treeview(table_frame, columns=("Project Name", "Customer", "Due Date"), show="headings")
table.heading("Project Name", text="Project Name")
table.heading("Customer", text="Customer")
table.heading("Due Date", text="Due Date")

# Configure the table to expand with the window
table.column("Project Name",width=150, anchor="center")
table.column("Customer", width=150, anchor="center")
table.column("Due Date", width=150, anchor="center")

# Pack the table
table.grid(row=0, column=0, sticky="nsew")

# Configure table frame layout
table_frame.grid_rowconfigure(0, weight=1)
table_frame.grid_columnconfigure(0, weight=1)

# Create a frame for buttons
button_frame = tk.Frame(root, width=100, height=100, bg="#414142")
button_frame.grid(row=2, column=0, columnspan=2,padx=30, pady=10, sticky="ew")

# Add buttons to the frame
add_project_button = ImageTk.PhotoImage(Image.open("Add_Project_V1.png"))
delete_selected_button = ImageTk.PhotoImage(Image.open("Delete_Selected_V1.png"))
view_history_button = ImageTk.PhotoImage(Image.open("View_History_V1.png"))
exit_button = ImageTk.PhotoImage(Image.open("exit.png"))
tk.Button(button_frame, width=150,height=50, image=add_project_button, command=open_form_popup, bg="#38761d", fg="white",highlightbackground="#414142").grid(row=0, column=0, padx=10, pady=5)
tk.Button(button_frame, width=150,height=50, image=delete_selected_button, command=delete_selected_data, bg="#38761d", fg="white", highlightbackground="#414142").grid(row=0, column=1, padx=10, pady=5)
tk.Button(button_frame, width=150,height=50, image=view_history_button, command=view_deleted_data, bg="#38761d", fg="white",highlightbackground="#414142").grid(row=0, column=2, padx=10, pady=5)
tk.Button(button_frame, width=150,height=50, image=exit_button, command=root.destroy, bg="#414142", fg="#414142",highlightbackground="#414142",borderwidth=0).grid(row=0, column=3, padx=10, pady=5) 

populate_table()

# Menyimpan data sebelum program ditutup
root.protocol("WM_DELETE_WINDOW", lambda: (save_data(DATA_FILE, get_all_table_data()), root.destroy()))

# Configure root layout
root.grid_rowconfigure(1, weight=1)
root.grid_columnconfigure(0, weight=1)

# Run the application
root.mainloop()
