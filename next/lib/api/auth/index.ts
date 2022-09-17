import { IFormLoginRequest, ILogiResponse, IRegisterResponse } from "@/models/auth";
import { Response } from "@/models/response";
import axios from "@/utils/axios";
import { AxiosError } from "axios";

export const useAuthApi = () => {
  const loginAction = async (form: IFormLoginRequest): Promise<Response<ILogiResponse> | Error>=> {
    try {
      return axios.get('/sanctum/csrf-cookie').then(async () => {
        const data = await axios.post<Response<ILogiResponse>>("/api/auth/login", form);
        if (data.status !== 200) {
          throw new Error(data.statusText);
        }
        return data.data;
      })
      .catch((error) => {
        throw error;
      });
    } catch (error) {
      throw error;
    }
  };

  const registerAction = async (form: IFormLoginRequest): Promise<Response<IRegisterResponse> | Error>=> {
    try {
      return axios.get('/sanctum/csrf-cookie').then(async () => {
        const data = await axios.post<Response<IRegisterResponse>>("/api/auth/register", form);
        if (![200, 204].includes(data.status)) {
          throw new Error(data.statusText);
        }
        return data.data;
      })
      .catch((error) => {
        throw error;
      });
    } catch (error) {
      throw error;
    }
  }

  return {
    loginAction,
    registerAction,
  };
};
