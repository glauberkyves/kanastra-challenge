import * as cmp from "@/components";
import { useQuery } from '@tanstack/react-query'
import {API_BACKEND} from "@/config/config.ts";
import {invoiceResponse} from "@/types/invoices.ts";
import {useState} from "react";

function invoice(){
  const [selectedFile, setSelectedFile] = useState(null);

  const handleFileChange = (event) => {
    setSelectedFile(event.target.files[0]);
  };

  const handleUpload = async (event) => {
    event.preventDefault();

    if (!selectedFile) {
      console.error('No file selected');
      return;
    }

    const formData = new FormData();
    formData.append('file', selectedFile);

    console.log(selectedFile, 33)

    try {
      const response = await fetch(`${API_BACKEND}/api/invoices/upload`, {
        method: 'POST',
        body: formData,
      });

      if (response.ok) {
        console.log('File uploaded successfully');
      } else {
        console.error('Failed to upload file');
      }
    } catch (error) {
      console.error('Error uploading file:', error);
    }
  };

  const fetchData = async () => {
    return await fetch(`${API_BACKEND}/api/invoices`).then(e => e.json());
  };

  const { data: result } = useQuery({
    queryKey: ['invoices'],
    queryFn: fetchData
  });

  return (
    <div>
      <h1>Invoices</h1>

      <form onSubmit={handleUpload}>
        <cmp.FileUploader file={selectedFile} onChange={handleFileChange} />
      </form>

        <cmp.Table>
          <cmp.TableHeader>
            <cmp.TableRow>
              <cmp.TableHead>id</cmp.TableHead>
              <cmp.TableHead>name</cmp.TableHead>
              <cmp.TableHead>government</cmp.TableHead>
              <cmp.TableHead>email</cmp.TableHead>
              <cmp.TableHead>amount</cmp.TableHead>
              <cmp.TableHead>due date</cmp.TableHead>
              <cmp.TableHead>debit</cmp.TableHead>
            </cmp.TableRow>
          </cmp.TableHeader>

          <cmp.TableBody>
            {result ? result?.data.map((e: invoiceResponse) => (<cmp.TableRow key={`invoices_${e.id}`}>
              <cmp.TableCell>{e.id}</cmp.TableCell>
              <cmp.TableCell>{e.name}</cmp.TableCell>
              <cmp.TableCell>{e.governmentId}</cmp.TableCell>
              <cmp.TableCell>{e.email}</cmp.TableCell>
              <cmp.TableCell>{e.debtAmount}</cmp.TableCell>
              <cmp.TableCell>{e.debtDueDate}</cmp.TableCell>
              <cmp.TableCell>{e.debtId}</cmp.TableCell>
            </cmp.TableRow>)) : null}
          </cmp.TableBody>
        </cmp.Table>
    </div>
);
}

export default invoice;
