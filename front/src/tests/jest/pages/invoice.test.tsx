import {fireEvent, waitFor} from '@testing-library/react';
import Invoice from "@/pages/invoice.tsx";
import '@testing-library/jest-dom'
import {renderWithQueryClient, setupTestQueryClient} from '@/tests/test-utils';

describe('Invoice Page', () => {
  test('deve renderizar a tabekla de invoices', async () => {
    const queryClient = setupTestQueryClient();
    const {getByText, getByLabelText} = renderWithQueryClient(<Invoice />, queryClient);

    await waitFor(() => {
      expect(getByText('Invoices')).toBeInTheDocument();
      expect(getByLabelText('Choose a file')).toBeInTheDocument();
      expect(getByText('id')).toBeInTheDocument();
      expect(getByText('name')).toBeInTheDocument();
      expect(getByText('government')).toBeInTheDocument();
      expect(getByText('email')).toBeInTheDocument();
      expect(getByText('amount')).toBeInTheDocument();
      expect(getByText('due date')).toBeInTheDocument();
      expect(getByText('debit')).toBeInTheDocument();
    });
  });

  test('updates selected file state on file input change', async () => {
    const queryClient = setupTestQueryClient();
    const { getByLabelText, getByText } = renderWithQueryClient(<Invoice />, queryClient);
    const fileInput = getByLabelText('Choose a file');

    fireEvent.change(fileInput, { target: { files: [new File(['file contents'], 'test.pdf')] } });

    await waitFor(() => {
      expect(getByText('Name')).toBeInTheDocument();
      expect(getByText('Type')).toBeInTheDocument();
      expect(getByText('Size')).toBeInTheDocument();
    });
  });
});
