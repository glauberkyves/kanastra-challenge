import {QueryClientProvider, QueryClient} from "@tanstack/react-query";
import {render} from "@testing-library/react";

export const setupTestQueryClient = () => {
  const queryClient = new QueryClient();
  return queryClient;
};

export const renderWithQueryClient = (component: React.ReactNode, queryClient?: QueryClient) => {
  return render(
    <QueryClientProvider client={queryClient || setupTestQueryClient()}>
      {component}
    </QueryClientProvider>
  );
};
